package com.programming.dsproject.hardwareservice.controller;
import com.programming.dsproject.hardwareservice.dto.DeviceDTO;
import com.programming.dsproject.hardwareservice.service.DeviceService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;


@RestController
@RequestMapping(value = "api/device")
@CrossOrigin
@Slf4j
public class DeviceController {

    @Autowired
    private DeviceService deviceService;


    @PostMapping("/saveDeviceNoData")
    public DeviceDTO saveDeviceNoData(@RequestBody DeviceDTO deviceDTO){
        System.out.println("ssfsf");
        return deviceService.saveDevicesNoData(deviceDTO);
    }



}
