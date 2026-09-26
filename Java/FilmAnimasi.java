public class FilmAnimasi extends Film {
    private String studio;
    private String negaraAsal;
    private String targetUsia;

    public FilmAnimasi() {
        studio = "";
        negaraAsal = "";
        targetUsia = "";
    }

    public void setStudio(String studio) {
        this.studio = studio;
    }

    public String getStudio() {
        return studio;
    }

    public void setNegaraAsal(String negaraAsal) {
        this.negaraAsal = negaraAsal;
    }

    public String getNegaraAsal() {
        return negaraAsal;
    }

    public void setTargetUsia(String targetUsia) {
        this.targetUsia = targetUsia;
    }

    public String getTargetUsia() {
        return targetUsia;
    }
}
