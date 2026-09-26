#include <iomanip>
#include <iostream>
#include <string>
#include <vector>
#include "FilmAnimasi3D.cpp"

using namespace std;

const string HEADER[] = {
    "ID", "Judul", "Genre", "Durasi (menit)", "Studio", "Negara asal",
    "Target usia", "Software 3D", "Mesin render", "Format model"
};

FilmAnimasi3D buatFilm(string id, string judul, string genre, int durasi,
                       string studio, string negaraAsal, string targetUsia,
                       string software3D, string mesinRender, string formatModel) {
    FilmAnimasi3D film;
    film.setId(id);
    film.setJudul(judul);
    film.setGenre(genre);
    film.setDurasi(durasi);
    film.setStudio(studio);
    film.setNegaraAsal(negaraAsal);
    film.setTargetUsia(targetUsia);
    film.setSoftware3D(software3D);
    film.setMesinRender(mesinRender);
    film.setFormatModel(formatModel);
    return film;
}

vector<string> ambilBaris(const FilmAnimasi3D& film) {
    vector<string> data;
    data.push_back(film.getId());
    data.push_back(film.getJudul());
    data.push_back(film.getGenre());
    data.push_back(to_string(film.getDurasi()));
    data.push_back(film.getStudio());
    data.push_back(film.getNegaraAsal());
    data.push_back(film.getTargetUsia());
    data.push_back(film.getSoftware3D());
    data.push_back(film.getMesinRender());
    data.push_back(film.getFormatModel());
    return data;
}

void cetakGaris(const vector<size_t>& lebar) {
    cout << '+';
    for (size_t i = 0; i < lebar.size(); i++) {
        for (size_t j = 0; j < lebar[i] + 2; j++) cout << '-';
        cout << '+';
    }
    cout << '\n';
}

void tampilkanTabel(const vector<FilmAnimasi3D>& daftar) {
    vector<vector<string>> baris;
    vector<string> judulKolom;
    for (int i = 0; i < 10; i++) judulKolom.push_back(HEADER[i]);
    baris.push_back(judulKolom);
    for (size_t i = 0; i < daftar.size(); i++) {
        baris.push_back(ambilBaris(daftar[i]));
    }
    vector<size_t> lebar(10, 0);
    for (size_t b = 0; b < baris.size(); b++) {
        for (size_t i = 0; i < lebar.size(); i++) {
            if (baris[b][i].size() > lebar[i]) lebar[i] = baris[b][i].size();
        }
    }
    cetakGaris(lebar);
    for (size_t b = 0; b < baris.size(); ++b) {
        cout << '|';
        for (size_t i = 0; i < lebar.size(); ++i) {
            cout << ' ' << left << setw(static_cast<int>(lebar[i]))
                 << baris[b][i] << " |";
        }
        cout << '\n';
        if (b == 0) cetakGaris(lebar);
    }
    cetakGaris(lebar);
    cout << "Jumlah data: " << daftar.size() << '\n';
}

string trim(const string& teks) {
    size_t awal = teks.find_first_not_of(" \t\r\n");
    if (awal == string::npos) return "";
    size_t akhir = teks.find_last_not_of(" \t\r\n");
    return teks.substr(awal, akhir - awal + 1);
}

bool bacaTeks(const string& label, string& hasil) {
    string masukan;
    while (true) {
        cout << label << ": ";
        if (!getline(cin, masukan)) return false;
        // CR hanya dibuang di akhir agar file CRLF dapat dibaca di semua OS.
        if (!masukan.empty() && masukan.back() == '\r') masukan.pop_back();
        bool kontrol = false;
        for (size_t i = 0; i < masukan.size(); i++) {
            unsigned char karakter = masukan[i];
            if (karakter < 32 || karakter == 127) kontrol = true;
        }
        hasil = trim(masukan);
        if (!hasil.empty() && !kontrol) return true;
        cout << "Input tidak boleh kosong atau mengandung karakter kontrol.\n";
    }
}

bool tambahFilm(vector<FilmAnimasi3D>& daftar) {
    string data[10];
    if (!bacaTeks(HEADER[0], data[0])) return false;
    for (size_t i = 0; i < daftar.size(); i++) {
        if (daftar[i].getId() == data[0]) {
            cout << "ID sudah digunakan.\n";
            return true;
        }
    }
    int durasi = 0;
    for (int i = 1; i < 10; i++) {
        while (true) {
            if (!bacaTeks(HEADER[i], data[i])) return false;
            if (i != 3) break;
            bool angka = data[i].size() <= 3;
            for (size_t j = 0; j < data[i].size(); j++) {
                if (data[i][j] < '0' || data[i][j] > '9') angka = false;
            }
            if (angka) {
                durasi = stoi(data[i]);
                if (durasi >= 1 && durasi <= 999) break;
            }
            cout << "Durasi harus berupa bilangan bulat 1-999.\n";
        }
    }
    daftar.push_back(buatFilm(data[0], data[1], data[2], durasi, data[4], data[5],
                             data[6], data[7], data[8], data[9]));
    cout << "Film berhasil ditambahkan.\n";
    tampilkanTabel(daftar);
    return true;
}

int main() {
    // Lima objek awal adalah data fiktif untuk praktikum.
    vector<FilmAnimasi3D> daftar;
    daftar.push_back(buatFilm("F001", "Petualangan Awan", "Fantasi", 95, "Studio Langit", "Indonesia", "Semua umur", "Blender", "Cycles", "FBX"));
    daftar.push_back(buatFilm("F002", "Robot Kota", "Fiksi ilmiah", 100, "Studio Mesin", "Indonesia", "7+", "Maya", "Arnold", "OBJ"));
    daftar.push_back(buatFilm("F003", "Laut Biru", "Petualangan", 88, "Studio Ombak", "Indonesia", "Semua umur", "Blender", "Eevee", "GLTF"));
    daftar.push_back(buatFilm("F004", "Hutan Cahaya", "Fantasi", 105, "Studio Rimba", "Indonesia", "7+", "Maya", "Arnold", "FBX"));
    daftar.push_back(buatFilm("F005", "Jejak Bintang", "Petualangan", 110, "Studio Orbit", "Indonesia", "13+", "Blender", "Cycles", "OBJ"));
    tampilkanTabel(daftar);
    string pilihan;
    while (true) {
        cout << "\n1. Tambah\n0. Keluar\n";
        if (!bacaTeks("Pilihan", pilihan) || pilihan == "0") break;
        if (pilihan == "1") {
            if (!tambahFilm(daftar)) break;
        } else {
            cout << "Menu tidak tersedia.\n";
        }
    }
    cout << "\nProgram selesai.\n";
    return 0;
}
