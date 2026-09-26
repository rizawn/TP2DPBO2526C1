class Film:
    def __init__(self):
        self.__id_film = ""
        self.__judul = ""
        self.__genre = ""
        self.__durasi = 0

    def set_id(self, id_film):
        self.__id_film = id_film

    def get_id(self):
        return self.__id_film

    def set_judul(self, judul):
        self.__judul = judul

    def get_judul(self):
        return self.__judul

    def set_genre(self, genre):
        self.__genre = genre

    def get_genre(self):
        return self.__genre

    def set_durasi(self, durasi):
        self.__durasi = durasi

    def get_durasi(self):
        return self.__durasi
