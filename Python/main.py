import sys
from FilmAnimasi3D import FilmAnimasi3D


HEADER = ["ID", "Judul", "Genre", "Durasi (menit)", "Studio", "Negara asal",
          "Target usia", "Software 3D", "Mesin render", "Format model"]


def buat_film(id_film, judul, genre, durasi, studio, negara_asal, target_usia,
              software_3d, mesin_render, format_model):
    film = FilmAnimasi3D()
    # Setter dari Film dan FilmAnimasi diwarisi oleh FilmAnimasi3D.
    film.set_id(id_film)
    film.set_judul(judul)
    film.set_genre(genre)
    film.set_durasi(durasi)
    film.set_studio(studio)
    film.set_negara_asal(negara_asal)
    film.set_target_usia(target_usia)
    film.set_software_3d(software_3d)
    film.set_mesin_render(mesin_render)
    film.set_format_model(format_model)
    return film


def baris_film(film):
    return [film.get_id(), film.get_judul(), film.get_genre(),
            str(film.get_durasi()), film.get_studio(), film.get_negara_asal(),
            film.get_target_usia(), film.get_software_3d(),
            film.get_mesin_render(), film.get_format_model()]


def baca_teks(pesan):
    while True:
        print(pesan + ": ", end="", flush=True)
        masukan = sys.stdin.readline()
        if masukan == "":
            return None
        masukan = masukan.rstrip("\r\n")
        kontrol = False
        for huruf in masukan:
            if ord(huruf) < 32 or ord(huruf) == 127:
                kontrol = True
        teks = masukan.strip()
        if teks != "" and not kontrol:
            return teks
        print("Input tidak boleh kosong atau mengandung karakter kontrol.")


def cetak_garis(lebar):
    garis = "+"
    for ukuran in lebar:
        garis += "-" * (ukuran + 2) + "+"
    print(garis)


def tampil_tabel(data):
    baris = [HEADER]
    for film in data:
        baris.append(baris_film(film))
    lebar = [0] * len(HEADER)
    for row in baris:
        for i in range(len(HEADER)):
            if len(row[i]) > lebar[i]:
                lebar[i] = len(row[i])
    cetak_garis(lebar)
    for nomor in range(len(baris)):
        hasil = "|"
        for i in range(len(HEADER)):
            hasil += " " + baris[nomor][i].ljust(lebar[i]) + " |"
        print(hasil)
        if nomor == 0:
            cetak_garis(lebar)
    cetak_garis(lebar)
    print("Jumlah data:", len(data))


def tambah_film(data):
    id_film = baca_teks("ID film")
    if id_film is None:
        return False
    for film in data:
        if film.get_id() == id_film:
            print("ID sudah digunakan.")
            return True

    nilai = [id_film]
    for i in range(1, len(HEADER)):
        selesai = False
        while not selesai:
            teks = baca_teks(HEADER[i])
            if teks is None:
                return False
            if i == 3:
                angka = 1 <= len(teks) <= 3
                for huruf in teks:
                    if huruf < "0" or huruf > "9":
                        angka = False
                if angka and int(teks) >= 1:
                    selesai = True
                else:
                    print("Durasi harus bilangan bulat 1-999.")
            else:
                selesai = True
        nilai.append(teks)

    # Objek disimpan hanya setelah sepuluh atribut lengkap.
    film = buat_film(nilai[0], nilai[1], nilai[2], int(nilai[3]), nilai[4],
                     nilai[5], nilai[6], nilai[7], nilai[8], nilai[9])
    data.append(film)
    print("Film berhasil ditambahkan.")
    tampil_tabel(data)
    return True


def main():
    # Lima objek awal, sebelum input. Data produksi adalah contoh fiktif.
    data = [
        buat_film("F001", "Petualangan Awan", "Fantasi", 95,
                  "Studio Langit", "Indonesia", "Semua umur", "Blender", "Cycles", "FBX"),
        buat_film("F002", "Robot Kota", "Fiksi ilmiah", 100,
                  "Studio Mesin", "Indonesia", "7+", "Maya", "Arnold", "OBJ"),
        buat_film("F003", "Laut Biru", "Petualangan", 88,
                  "Studio Ombak", "Indonesia", "Semua umur", "Blender", "Eevee", "GLTF"),
        buat_film("F004", "Hutan Cahaya", "Fantasi", 105,
                  "Studio Rimba", "Indonesia", "7+", "Maya", "Arnold", "FBX"),
        buat_film("F005", "Jejak Bintang", "Petualangan", 110,
                  "Studio Orbit", "Indonesia", "13+", "Blender", "Cycles", "OBJ"),
    ]
    tampil_tabel(data)
    while True:
        print("\n1. Tambah\n0. Keluar")
        menu = baca_teks("Pilihan")
        if menu is None or menu == "0":
            break
        if menu == "1":
            if not tambah_film(data):
                break
        else:
            print("Menu tidak tersedia.")
    print("\nProgram selesai.")


if __name__ == "__main__":
    main()
