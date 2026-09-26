public class FilmAnimasi3D extends FilmAnimasi {
    private String software3D;
    private String mesinRender;
    private String formatModel;

    public FilmAnimasi3D() {
        software3D = "";
        mesinRender = "";
        formatModel = "";
    }

    public void setSoftware3D(String software3D) {
        this.software3D = software3D;
    }

    public String getSoftware3D() {
        return software3D;
    }

    public void setMesinRender(String mesinRender) {
        this.mesinRender = mesinRender;
    }

    public String getMesinRender() {
        return mesinRender;
    }

    public void setFormatModel(String formatModel) {
        this.formatModel = formatModel;
    }

    public String getFormatModel() {
        return formatModel;
    }
}
