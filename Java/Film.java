public class Film {
    private String idFilm;
    private String judul;
    private String genre;
    private int durasi;

    public Film() {
        idFilm = "";
        judul = "";
        genre = "";
        durasi = 0;
    }

    public void setId(String idFilm) {
        this.idFilm = idFilm;
    }

    public String getId() {
        return idFilm;
    }

    public void setJudul(String judul) {
        this.judul = judul;
    }

    public String getJudul() {
        return judul;
    }

    public void setGenre(String genre) {
        this.genre = genre;
    }

    public String getGenre() {
        return genre;
    }

    public void setDurasi(int durasi) {
        this.durasi = durasi;
    }

    public int getDurasi() {
        return durasi;
    }
}
