import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.applications import MobileNetV2
from tensorflow.keras import layers, models
import numpy as np
import os

# 1. KONFIGURASI
IMG_SIZE = 224
BATCH_SIZE = 32
EPOCHS = 15  # Dinaikkan sedikit agar fine-tuning maksimal
BASE_DIR = 'dataset'

# 2. DATA AUGMENTASI (Lebih Agresif untuk Glaukoma)
datagen = ImageDataGenerator(
    rescale=1./255,
    rotation_range=30,
    width_shift_range=0.2,
    height_shift_range=0.2,
    brightness_range=[0.7, 1.3], # Variasi cahaya lebih luas untuk deteksi mata merah
    zoom_range=0.3, 
    horizontal_flip=True,
    fill_mode='nearest',
    validation_split=0.2
)

train_generator = datagen.flow_from_directory(
    BASE_DIR,
    target_size=(IMG_SIZE, IMG_SIZE),
    batch_size=BATCH_SIZE,
    class_mode='categorical',
    subset='training',
    shuffle=True
)

val_generator = datagen.flow_from_directory(
    BASE_DIR,
    target_size=(IMG_SIZE, IMG_SIZE),
    batch_size=BATCH_SIZE,
    class_mode='categorical',
    subset='validation'
)

# 3. MENGHITUNG CLASS WEIGHTS
from sklearn.utils.class_weight import compute_class_weight
unique_labels = np.unique(train_generator.classes)
weights = compute_class_weight(class_weight='balanced', classes=unique_labels, y=train_generator.classes)
class_weights = dict(zip(unique_labels, weights))

print(f"✅ Label Kelas: {train_generator.class_indices}")
print(f"✅ Bobot Penyeimbang (Class Weights): {class_weights}")

# 4. MEMBANGUN MODEL DENGAN FINE-TUNING
base_model = MobileNetV2(weights='imagenet', include_top=False, input_shape=(IMG_SIZE, IMG_SIZE, 3))

# --- BAGIAN KRUSIAL: FINE TUNING ---
base_model.trainable = True
# Kita kunci (freeze) 100 layer pertama, buka layer sisanya untuk belajar fitur mata spesifik
for layer in base_model.layers[:100]:
    layer.trainable = False

model = models.Sequential([
    base_model,
    layers.GlobalAveragePooling2D(),
    layers.BatchNormalization(), # Menstabilkan training
    layers.Dropout(0.4),         # Mencegah overfitting
    layers.Dense(256, activation='relu'),
    layers.Dense(train_generator.num_classes, activation='softmax')
])

# Menggunakan Learning Rate yang sangat kecil untuk Fine-Tuning
model.compile(
    optimizer=tf.keras.optimizers.Adam(learning_rate=0.00001), 
    loss='categorical_crossentropy', 
    metrics=['accuracy']
)

# 5. MULAI TRAINING
print("\n🚀 Memulai Training dengan Fine-Tuning... Harap tunggu.")
history = model.fit(
    train_generator,
    validation_data=val_generator,
    epochs=EPOCHS,
    class_weight=class_weights,
    verbose=1
)

# 6. SIMPAN MODEL
model.save('model_mata_expert.h5')
print("\n✅ SELESAI! Model baru 'model_mata_expert.h5' telah diperbarui.")