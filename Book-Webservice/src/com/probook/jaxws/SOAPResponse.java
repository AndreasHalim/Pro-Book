package com.probook.jaxws;

import com.googlebooks.api.Buku;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlRootElement;

@XmlAccessorType(XmlAccessType.PROPERTY)
@XmlRootElement(name="Result")
public class SOAPResponse {
    @XmlElement(name = "jumlahBuku")
    private int jumlah;
    @XmlElement(name = "buku")
    private Buku[] buku;

    public SOAPResponse() {}

    public void setBuku(Buku[] buku) {
        this.buku = buku;
        this.jumlah = buku.length;
    }
}
