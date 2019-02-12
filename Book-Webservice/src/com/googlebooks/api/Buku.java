package com.googlebooks.api;

import javax.xml.bind.annotation.*;
import java.io.Serializable;

@XmlAccessorType(XmlAccessType.PROPERTY)
@XmlRootElement(name="Buku")
public class Buku implements Serializable {
    private static final long serialVersionUID = -5577579081118070434L;

    @XmlElement(name = "idBuku")
    private String id_buku;
    @XmlElement(name = "judul")
    private String judul;
    @XmlElement(name = "isForSale")
    private Boolean isForSale;
    @XmlElement(name = "pengarang")
    private String pengarang;
    @XmlElement(name = "deskripsi")
    private String deskripsi;
    @XmlElement(name = "kategori")
    private String[] kategori;
    @XmlElement(name = "harga")
    private int harga;
    @XmlElement(name = "mataUang")
    private String mataUang;
    @XmlElement(name = "gambar")
    private String gambar;
    @XmlElement(name = "rating")
    private Double rating;

    public Buku() {}

    public Buku(String id_buku, Boolean isForSale, String judul, String pengarang, String deskripsi, String[] kategori, int harga, String mataUang, String gambar, Double rating) {
        this.id_buku = id_buku;
        this.isForSale = isForSale;
        this.judul = judul;
        this.pengarang = pengarang;
        this.deskripsi = deskripsi;
        this.kategori = kategori;
        this.harga = harga;
        this.mataUang = mataUang;
        this.gambar = gambar;
        this.rating = rating;
    }

    public String getIdBuku() {
        return this.id_buku;
    }

    public int getHarga() {
        return this.harga;
    }

    public String[] getKategori() {
        return this.kategori;
    }

    public Double getRating() { return this.rating; }

    @Override
    public String toString() {
        return id_buku + "::" + judul + "::" + pengarang;
    }
}
