import pandas as pd
import shutil
import os

# 1. Konfigurasi Nama File dan Folder
file_csv = 'full_df.csv'
folder_sumber = 'preprocessed_images'
base_dir = 'dataset'
categories = ['normal', 'cataract', 'glaucoma']

# 2. Buat folder dataset jika belum ada
for cat in categories:
    os.makedirs(os.path.join(base_dir, cat), exist_ok=True)

# 3. Baca file CSV
try:
    df = pd.read_csv(file_csv)
    print(f"✅ Berhasil membaca {file_csv}")
except Exception as e:
    print(f"❌ Gagal membaca CSV: {e}")
    exit()

print("Memulai proses sortir gambar... Harap tunggu.")

# Counter untuk laporan akhir
counts = {'cataract': 0, 'glaucoma': 0, 'normal': 0}

# 4. Looping data
for index, row in df.iterrows():
    # Cek mata kiri dan kanan
    for side in ['Left', 'Right']:
        img_name = row[f'{side}-Fundus']
        source_path = os.path.join(folder_sumber, img_name)
        
        # Jika file gambar ditemukan di folder preprocessed_images
        if os.path.exists(source_path):
            # Logika Katarak (Kolom 'C')
            if row['C'] == 1 and 'cataract' in str(row[f'{side}-Diagnostic Keywords']).lower():
                shutil.copy(source_path, os.path.join(base_dir, 'cataract', img_name))
                counts['cataract'] += 1
            
            # Logika Glaukoma (Kolom 'G')
            elif row['G'] == 1 and 'glaucoma' in str(row[f'{side}-Diagnostic Keywords']).lower():
                shutil.copy(source_path, os.path.join(base_dir, 'glaucoma', img_name))
                counts['glaucoma'] += 1
            
            # Logika Normal (Kolom 'N')
            elif row['N'] == 1:
                shutil.copy(source_path, os.path.join(base_dir, 'normal', img_name))
                counts['normal'] += 1

print(f"\n--- ✅ PROSES SELESAI ---")
print(f"Gambar Katarak  : {counts['cataract']}")
print(f"Gambar Glaukoma : {counts['glaucoma']}")
print(f"Gambar Normal   : {counts['normal']}")
print(f"Silakan cek folder: {os.path.abspath(base_dir)}")