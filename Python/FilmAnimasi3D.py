from FilmAnimasi import FilmAnimasi


class FilmAnimasi3D(FilmAnimasi):
    def __init__(self):
        super().__init__()
        self.__software_3d = ""
        self.__mesin_render = ""
        self.__format_model = ""

    def set_software_3d(self, software_3d):
        self.__software_3d = software_3d

    def get_software_3d(self):
        return self.__software_3d

    def set_mesin_render(self, mesin_render):
        self.__mesin_render = mesin_render

    def get_mesin_render(self):
        return self.__mesin_render

    def set_format_model(self, format_model):
        self.__format_model = format_model

    def get_format_model(self):
        return self.__format_model
