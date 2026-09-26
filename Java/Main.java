import java.util.ArrayList;
import java.util.Scanner;

public class Main {
    private static final String[] HEADER = {
        "ID", "Judul", "Genre", "Durasi (menit)", "Studio", "Negara asal",
        "Target usia", "Software 3D", "Mesin render", "Format model"
    };

    private static FilmAnimasi3D buatFilm(String id, String judul, String genre, int durasi,
                                          String studio, String negaraAsal, String targetUsia,
                                          String software3D, String mesinRender, String formatModel) {
        FilmAnimasi3D film = new FilmAnimasi3D();
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

    private static String[] ambilBaris(FilmAnimasi3D film) {
        String[] data = {
            film.getId(), film.getJudul(), film.getGenre(),
            String.valueOf(film.getDurasi()), film.getStudio(), film.getNegaraAsal(),
            film.getTargetUsia(), film.getSoftware3D(), film.getMesinRender(),
            film.getFormatModel()
        };
        return data;
    }

    private static void cetakGaris(int[] lebar) {
        System.out.print('+');
        for (int i = 0; i < lebar.length; i++) {
            for (int j = 0; j < lebar[i] + 2; j++) System.out.print('-');
            System.out.print('+');
        }
        System.out.println();
    }

    private static void tampilkanTabel(ArrayList<FilmAnimasi3D> daftar) {
        String[][] baris = new String[daftar.size() + 1][10];
        baris[0] = HEADER;
        for (int i = 0; i < daftar.size(); i++) baris[i + 1] = ambilBaris(daftar.get(i));
        int[] lebar = new int[HEADER.length];
        for (int b = 0; b < baris.length; b++) {
            for (int i = 0; i < lebar.length; i++) {
                if (baris[b][i].length() > lebar[i]) lebar[i] = baris[b][i].length();
            }
        }
        cetakGaris(lebar);
        for (int b = 0; b < baris.length; b++) {
            System.out.print('|');
            for (int i = 0; i < lebar.length; i++) {
                System.out.printf(" %-" + lebar[i] + "s |", baris[b][i]);
            }
            System.out.println();
            if (b == 0) cetakGaris(lebar);
        }
        cetakGaris(lebar);
        System.out.println("Jumlah data: " + daftar.size());
    }

    private static String bacaTeks(Scanner input, String label) {
        while (true) {
            System.out.print(label + ": ");
            if (!input.hasNextLine()) return null;
            String masukan = input.nextLine();
            boolean kontrol = false;
            for (int i = 0; i < masukan.length(); i++) {
                if (Character.isISOControl(masukan.charAt(i))) kontrol = true;
            }
            String hasil = masukan.trim();
            if (!hasil.isEmpty() && !kontrol) return hasil;
            System.out.println("Input tidak boleh kosong atau mengandung karakter kontrol.");
        }
    }

    private static boolean tambahFilm(Scanner input, ArrayList<FilmAnimasi3D> daftar) {
        String[] data = new String[HEADER.length];
        data[0] = bacaTeks(input, HEADER[0]);
        if (data[0] == null) return false;
        for (int i = 0; i < daftar.size(); i++) {
            if (daftar.get(i).getId().equals(data[0])) {
                System.out.println("ID sudah digunakan.");
                return true;
            }
        }
        int durasi = 0;
        for (int i = 1; i < data.length; i++) {
            while (true) {
                data[i] = bacaTeks(input, HEADER[i]);
                if (data[i] == null) return false;
                if (i != 3) break;
                boolean angka = data[i].length() <= 3;
                for (int j = 0; j < data[i].length(); j++) {
                    if (data[i].charAt(j) < '0' || data[i].charAt(j) > '9') angka = false;
                }
                if (angka) {
                    durasi = Integer.parseInt(data[i]);
                    if (durasi >= 1 && durasi <= 999) break;
                }
                System.out.println("Durasi harus berupa bilangan bulat 1-999.");
            }
        }
        daftar.add(buatFilm(data[0], data[1], data[2], durasi, data[4], data[5],
                            data[6], data[7], data[8], data[9]));
        System.out.println("Film berhasil ditambahkan.");
        tampilkanTabel(daftar);
        return true;
    }

    public static void main(String[] args) {
        // Lima objek awal adalah data fiktif untuk praktikum.
        ArrayList<FilmAnimasi3D> daftar = new ArrayList<FilmAnimasi3D>();
        daftar.add(buatFilm("F001", "Petualangan Awan", "Fantasi", 95, "Studio Langit", "Indonesia", "Semua umur", "Blender", "Cycles", "FBX"));
        daftar.add(buatFilm("F002", "Robot Kota", "Fiksi ilmiah", 100, "Studio Mesin", "Indonesia", "7+", "Maya", "Arnold", "OBJ"));
        daftar.add(buatFilm("F003", "Laut Biru", "Petualangan", 88, "Studio Ombak", "Indonesia", "Semua umur", "Blender", "Eevee", "GLTF"));
        daftar.add(buatFilm("F004", "Hutan Cahaya", "Fantasi", 105, "Studio Rimba", "Indonesia", "7+", "Maya", "Arnold", "FBX"));
        daftar.add(buatFilm("F005", "Jejak Bintang", "Petualangan", 110, "Studio Orbit", "Indonesia", "13+", "Blender", "Cycles", "OBJ"));
        tampilkanTabel(daftar);
        Scanner input = new Scanner(System.in);
        while (true) {
            System.out.println("\n1. Tambah\n0. Keluar");
            String pilihan = bacaTeks(input, "Pilihan");
            if (pilihan == null || pilihan.equals("0")) break;
            if (pilihan.equals("1")) {
                if (!tambahFilm(input, daftar)) break;
            } else {
                System.out.println("Menu tidak tersedia.");
            }
        }
        input.close();
        System.out.println("\nProgram selesai.");
    }
}
