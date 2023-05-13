package com.programming.dsproject.deviceservice.service;

import com.programming.dsproject.deviceservice.dto.DeviceDTO;
import com.programming.dsproject.deviceservice.entity.Devices;
import com.programming.dsproject.deviceservice.repo.DeviceRepo;
import jakarta.transaction.Transactional;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
@Transactional
@Slf4j
public class DeviceService {

    @Autowired
    private DeviceRepo deviceRepo;

    @Autowired
    private ModelMapper modelMapper;

    public List<DeviceDTO> getDevice(){

        log.info("Placing Order");
        List<Devices>devicesList=deviceRepo.findAll();
        return modelMapper.map(devicesList, new TypeToken<List<DeviceDTO>>(){}.getType());
    }

    public DeviceDTO saveDevices(DeviceDTO deviceDTO){
        deviceRepo.save(modelMapper.map(deviceDTO, Devices.class));
        return deviceDTO;
    }

    public DeviceDTO updateDevices(DeviceDTO deviceDTO){
        deviceRepo.save(modelMapper.map(deviceDTO,Devices.class));
        return deviceDTO;
    }

    public boolean deleteDevices(DeviceDTO deviceDTO){
        deviceRepo.delete(modelMapper.map(deviceDTO,Devices.class));
        return true;
    }

    public boolean getdDeviseExist(String deviceName){
        return deviceRepo.findById(deviceName).isPresent();
    }

    public DeviceDTO getDeviceByEmail(String email){
         Devices devices = deviceRepo.getDevicesByEmail(email);
        System.out.println(devices);
        if(devices != null){
            return modelMapper.map(devices,DeviceDTO.class);
        }else {

            DeviceDTO device = new DeviceDTO();

            return device;
        }
    }

}
