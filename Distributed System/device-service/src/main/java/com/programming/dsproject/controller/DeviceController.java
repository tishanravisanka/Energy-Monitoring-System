package com.programming.dsproject.controller;
import com.programming.dsproject.dto.DeviceDTO;
import com.programming.dsproject.service.DeviceService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping(value = "api/devicelist")
@CrossOrigin
@Slf4j
public class DeviceController {

    @Autowired
    private DeviceService deviceService;

    //Get all device data
    @GetMapping("/getDevice")
    public List<DeviceDTO> getDevice(){
        return deviceService.getDevice();
    }

    //Add device data
    @PostMapping("/saveDevice")
    public DeviceDTO saveDevices(@RequestBody DeviceDTO deviceDTO){
        System.out.println("ssfsf");
        return deviceService.saveDevices(deviceDTO);
    }

    @GetMapping("/getDeviceExist/{name}")
    public boolean getDeviceExist(@PathVariable String name){
        System.out.println(name);
        return deviceService.getdDeviseExist(name);
    }

    @PutMapping("/updateDevice")
    public DeviceDTO updateUser(@RequestBody DeviceDTO deviceDTO){
        return deviceService.updateDevices(deviceDTO);
    }

    @DeleteMapping("/deleteDevice")
    public boolean deleteDevices(@RequestBody DeviceDTO deviceDTO){
        return deviceService.deleteDevices(deviceDTO);
    }


    @GetMapping("/getDeviceData/{email}")
    public  DeviceDTO getDeviceByEmail(@PathVariable String email){
        System.out.println(email);
        return deviceService.getDeviceByEmail(email);
    }

}
