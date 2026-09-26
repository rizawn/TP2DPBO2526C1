from Film import Film


class FilmAnimasi(Film):
    def __init__(self):
        super().__init__()
        self.__studio = ""
        self.__negara_asal = ""
        self.__target_usia = ""

    def set_studio(self, studio):
        self.__studio = studio

    def get_studio(self):
        return self.__studio

    def set_negara_asal(self, negara_asal):
        self.__negara_asal = negara_asal

    def get_negara_asal(self):
        return self.__negara_asal

    def set_target_usia(self, target_usia):
        self.__target_usia = target_usia

    def get_target_usia(self):
        return self.__target_usia
