package com.programming.dsproject.availabilitycheckservice.controller;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;


@RestController
@RequestMapping(value = "check")
@CrossOrigin
@Slf4j
public class AvailabilityCheckController {

    @Autowired


    @PostMapping("/availability")
    public String saveDeviceNoData(){
        System.out.println("System available");
        return "System available";
    }



}
