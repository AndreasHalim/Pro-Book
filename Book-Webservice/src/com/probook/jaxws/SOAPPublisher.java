package com.probook.jaxws;

import javax.xml.ws.Endpoint;

//Endpoint publisher
public class SOAPPublisher{

    public static void main(String[] args) {
        Endpoint.publish("http://localhost:9000/bookservice", new BookServiceImpl());
    }

}