import os
import tensorflow as tf
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.applications import MobileNetV2
from tensorflow.keras import layers, models
from tensorflow.keras.callbacks import EarlyStopping, ModelCheckpoint, ReduceLROnPlateau

# ==============================================================================
# 1. KONFIGURASI
# ==============================================================================
IMG_SIZE   = 224
BATCH_SIZE = 16
EPOCHS     = 80  # Dinaikkan ke 80 untuk 8 kelas

BASE_DIR    = os.path.dirname(os.path.abspath(__file__))
DATASET_DIR = os.path.join(BASE_DIR, 'dataset')

# ==============================================================================
# 2. VALIDASI DATASET
# ==============================================================================
EXPECTED_CLASSES = [
    'bukan_mata',
    'cataract',
    'daging_tumbuh_pterygium',
    'hordeolum_bintitan',
    'iritasi_mata',
    'mata_berdarah_hermohage',
    'mata_berkacamata',
    'normal',
]

print(f"🔍 Membaca dataset dari: {DATASET_DIR}")
print(f"📂 Kelas yang diharapkan ({len(EXPECTED_CLASSES)} kelas):")
for i, c in enumerate(EXPECTED_CLASSES):
    folder = os.path.join(DATASET_DIR, c)
    count  = len([f for f in os.listdir(folder) if os.path.isfile(os.path.join(folder, f))]) if os.path.exists(folder) else 0
    status = "✅" if count > 0 else "❌ KOSONG"
    print(f"   {i+1}. {c:<35} → {count} gambar {status}")

# ==============================================================================
# 3. DATA AUGMENTASI
# ==============================================================================
datagen = ImageDataGenerator(
    rescale=1./255,
    rotation_range=40,
    width_shift_range=0.25,
    height_shift_range=0.25,
    brightness_range=[0.5, 1.5],   # Antisipasi foto gelap & backlight
    zoom_range=[0.6, 1.4],         # Belajar dari jarak selfie hingga macro
    horizontal_flip=True,
    shear_range=0.2,
    channel_shift_range=30.0,      # Variasi warna untuk foto HP
    fill_mode='nearest',
    validation_split=0.2
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
    subset='validation',
    shuffle=False
)

print(f"\n✅ Label Kelas yang Dikenali Model: {train_generator.class_indices}")
NUM_CLASSES = train_generator.num_classes
print(f"📊 Jumlah kelas: {NUM_CLASSES}")
print(f"📊 Total data latih: {train_generator.samples} gambar")
print(f"📊 Total data validasi: {val_generator.samples} gambar")

# ==============================================================================
# 4. MEMBANGUN MODEL
# ==============================================================================
print("\n⚙️ Membangun Arsitektur Model...")

base_model = MobileNetV2(
    weights='imagenet',
    include_top=False,
    input_shape=(IMG_SIZE, IMG_SIZE, 3)
)

base_model.trainable = True

# Kunci 100 layer pertama
for layer in base_model.layers[:100]:
    layer.trainable = False

model = models.Sequential([
    base_model,
    layers.GlobalAveragePooling2D(),
    layers.BatchNormalization(),
    layers.Dropout(0.5),           # Dinaikkan ke 0.5 untuk 8 kelas
    layers.Dense(256, activation='relu'),  # Dinaikkan ke 256 untuk kapasitas lebih besar
    layers.BatchNormalization(),
    layers.Dropout(0.4),
    layers.Dense(128, activation='relu'),
    layers.BatchNormalization(),
    layers.Dropout(0.3),
    layers.Dense(NUM_CLASSES, activation='softmax')
])

# ==============================================================================
# 5. KOMPILASI
# ==============================================================================
optimizer = tf.keras.optimizers.Adam(learning_rate=0.00001)

model.compile(
    optimizer=optimizer,
    loss='categorical_crossentropy',
    metrics=['accuracy']
)

model.summary()

# ==============================================================================
# 6. TRAINING
# ==============================================================================
MODEL_OUTPUT = os.path.join(BASE_DIR, 'model_mata_expert.h5')

callbacks = [
    ModelCheckpoint(
        MODEL_OUTPUT,
        monitor='val_accuracy',
        save_best_only=True,
        mode='max',
        verbose=1
    ),
    EarlyStopping(
        monitor='val_accuracy',
        patience=15,               # Dinaikkan ke 15 untuk 8 kelas
        restore_best_weights=True,
        verbose=1
    ),
    ReduceLROnPlateau(             # Tambahan: kurangi LR otomatis jika mentok
        monitor='val_loss',
        factor=0.5,
        patience=5,
        min_lr=1e-7,
        verbose=1
    ),
]

print(f"\n🚀 Memulai Training {NUM_CLASSES} kelas...")
print("=" * 60)

history = model.fit(
    train_generator,
    validation_data=val_generator,
    epochs=EPOCHS,
    callbacks=callbacks,
    verbose=1
)

# ==============================================================================
# 7. RINGKASAN HASIL
# ==============================================================================
best_val_acc = max(history.history['val_accuracy'])
best_epoch   = history.history['val_accuracy'].index(best_val_acc) + 1

print("\n" + "=" * 60)
print(f"✅ SELESAI! Model terbaik disimpan di: {MODEL_OUTPUT}")
print(f"🏆 Akurasi validasi terbaik: {best_val_acc*100:.2f}% (Epoch {best_epoch})")
print("=" * 60)