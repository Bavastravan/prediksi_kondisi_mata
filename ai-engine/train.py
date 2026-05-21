import os
import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.applications import MobileNetV2
from tensorflow.keras import layers, models

# 1. KONFIGURASI (Disesuaikan agar sangat ringan untuk laptop)
IMG_SIZE = 224
BATCH_SIZE = 32
EPOCHS = 50  # 12 Epochs sudah sangat cukup karena base model dikunci (cepat selesai)

# Mengunci path agar akurat mengarah ke folder dataset di dalam ai-engine
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
DATASET_DIR = os.path.join(BASE_DIR, 'dataset')

print(f"🔍 Membaca dataset dari: {DATASET_DIR}")

# 2. DATA AUGMENTASI (Disesuaikan untuk 6 kelas baru, efisien & tidak membebani RAM)
datagen = ImageDataGenerator(
    rescale=1./255,
    rotation_range=20,
    width_shift_range=0.1,
    height_shift_range=0.1,
    brightness_range=[0.8, 1.2], 
    zoom_range=0.2, 
    horizontal_flip=True,
    fill_mode='nearest',
    validation_split=0.2 # 80% Latih, 20% Validasi
)

train_generator = datagen.flow_from_directory(
    DATASET_DIR,
    target_size=(IMG_SIZE, IMG_SIZE),
    batch_size=BATCH_SIZE,
    class_mode='categorical',
    subset='training',
    shuffle=True
)

val_generator = datagen.flow_from_directory(
    DATASET_DIR,
    target_size=(IMG_SIZE, IMG_SIZE),
    batch_size=BATCH_SIZE,
    class_mode='categorical',
    subset='validation'
)

print(f"✅ Urutan Label Kelas untuk Web: {train_generator.class_indices}")

# ==============================================================================
# 3. MEMBANGUN MODEL (Transfer Learning + Fine-Tuning Cerdas)
# ==============================================================================
# Memuat MobileNetV2 yang sudah terlatih dari ImageNet
base_model = MobileNetV2(weights='imagenet', include_top=False, input_shape=(IMG_SIZE, IMG_SIZE, 3))

# 💡 BUKA KUNCI BASE MODEL (Fine-Tuning)
base_model.trainable = True 

# 🔒 Kunci 100 layer pertama agar RAM laptopmu tidak jebol dan training tetap ringan.
# Hanya layer-layer atas saja yang kita izinkan mengenali pola bintitan, uveitis, dan belekan.
for layer in base_model.layers[:100]:
    layer.trainable = False

model = models.Sequential([
    base_model,
    layers.GlobalAveragePooling2D(),
    layers.BatchNormalization(), 
    layers.Dropout(0.4),         # Dinaikkan ke 0.4 agar di Epoch 50 model TIDAK overfitting (menghafal)
    layers.Dense(128, activation='relu'), 
    layers.Dense(train_generator.num_classes, activation='softmax')
])

# ⚠️ JANGKAR EMAS: Diturunkan ke 0.00001 (Lebih kecil 10x lipat dari kemarin)
# Ini wajib hukumnya saat fine-tuning agar bobot bawaan ImageNet tidak rusak berantakan
model.compile(
    optimizer=tf.keras.optimizers.Adam(learning_rate=0.00001), 
    loss='categorical_crossentropy', 
    metrics=['accuracy']
)

model.summary()

# 4. MULAI TRAINING
print("\n🚀 Memulai Training Ringan... Proses ini akan jauh lebih cepat!")
history = model.fit(
    train_generator,
    validation_data=val_generator,
    epochs=EPOCHS,
    verbose=1
)

# 5. SIMPAN MODEL
MODEL_OUTPUT = os.path.join(BASE_DIR, 'model_mata_expert.h5')
model.save(MODEL_OUTPUT)
print(f"\n✅ SELESAI! Model pintar berhasil disimpan di: {MODEL_OUTPUT}")