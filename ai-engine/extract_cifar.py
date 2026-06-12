import numpy as np
import os
import cv2
import pickle # 💡 PERBAIKAN: Modul ini wajib di-import

# ==============================================================================
# SCRIPT EKSTRAKSI CIFAR-10 UNTUK KELAS "bukan_mata"
# ==============================================================================

def unpickle(file):
    with open(file, 'rb') as fo:
        dict = pickle.load(fo, encoding='bytes')
    return dict

# 1. Tentukan folder output
# Menggunakan path dinamis agar selalu mengarah ke ai-engine/dataset/bukan_mata
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
output_dir = os.path.join(BASE_DIR, 'dataset', 'bukan_mata')

if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# 2. Path ke file CIFAR-10 yang sudah diekstrak (data_batch_1)
# Sesuaikan path ini dengan lokasi kamu mengekstrak CIFAR-10.
# Jika folder cifar-10-batches-py ada di dalam folder ai-engine:
batch_file = os.path.join(BASE_DIR, 'cifar-10-batches-py', 'data_batch_1')

try:
    print(f"Membaca file data_batch_1 dari: {batch_file}")
    data_dict = unpickle(batch_file)
    images = data_dict[b'data']
    
    # Reshape data menjadi (10000, 3, 32, 32) lalu transpose ke (10000, 32, 32, 3) format RGB
    images = images.reshape(10000, 3, 32, 32).transpose(0, 2, 3, 1)

    print(f"Menyimpan gambar ke folder {output_dir}...")
    
    # Ambil 500 gambar pertama untuk diseimbangkan dengan dataset mata
    for i in range(500):
        # CIFAR-10 formatnya RGB, kita perlu convert ke BGR untuk disimpan oleh OpenCV
        img_bgr = cv2.cvtColor(images[i], cv2.COLOR_RGB2BGR)
        
        # Simpan gambar
        file_path = os.path.join(output_dir, f'bukan_mata_cifar_{i}.jpg')
        cv2.imwrite(file_path, img_bgr)
        
    print(f"✅ Berhasil! 500 gambar CIFAR-10 telah disimpan di: {output_dir}")
    print("Sekarang kamu bisa menjalankan: python train.py")

except FileNotFoundError:
    print("\n❌ ERROR FILE TIDAK DITEMUKAN ❌")
    print("Pastikan kamu sudah mengekstrak dataset CIFAR-10 (cifar-10-python.tar.gz)")
    print(f"Sistem mencari file di lokasi ini:\n{batch_file}")