import pickle
import numpy as np
import os
import cv2

def unpickle(file):
    with open(file, 'rb') as fo:
        dict = pickle.load(fo, encoding='bytes')
    return dict

# 1. Tentukan folder output
output_dir = 'dataset/bukan_mata'
if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# 2. Path ke file yang sudah kamu download (pastikan namanya sesuai)
# Jika sudah diekstrak manual, arahkan ke folder 'cifar-10-batches-py/data_batch_1'
batch_file = 'cifar-10-batches-py/data_batch_1' 

try:
    data_dict = unpickle(batch_file)
    images = data_dict[b'data']
    
    # Reshape data menjadi (10000, 3, 32, 32) lalu transpose ke (10000, 32, 32, 3)
    images = images.reshape(10000, 3, 32, 32).transpose(0, 2, 3, 1)

    print("Menyimpan gambar ke folder bukan_mata...")
    # Ambil 500 gambar saja supaya seimbang dengan dataset mata kamu
    for i in range(500):
        img_bgr = cv2.cvtColor(images[i], cv2.COLOR_RGB2BGR)
        cv2.imwrite(os.path.join(output_dir, f'bukan_mata_{i}.jpg'), img_bgr)
        
    print(f"✅ Berhasil! 500 gambar tersimpan di {output_dir}")

except FileNotFoundError:
    print("❌ Error: Folder 'cifar-10-batches-py' tidak ditemukan. Ekstrak dulu tar.gz nya!")