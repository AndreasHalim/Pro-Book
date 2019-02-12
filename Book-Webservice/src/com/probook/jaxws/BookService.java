package com.probook.jaxws;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

//Service Endpoint Interface
@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {
    @WebMethod
    String getHelloWorldString(String name);

    @WebMethod
    boolean insertPurchase(String id_buku, int jml, String no_kartu);

    @WebMethod
    SOAPResponse searchBooks(String input);

    @WebMethod
    SOAPResponse getRekomendasi(String[] Category);

    @WebMethod
    SOAPResponse getBookByID(String id, String author);
}
