package com.programming.dsproject.service;

import com.programming.dsproject.dto.DeviceDTO;
import com.programming.dsproject.entity.Devices;
import com.programming.dsproject.repo.DeviceRepo;
import jakarta.transaction.Transactional;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
@Transactional
public class DeviceService {

    @Autowired
    private DeviceRepo deviceRepo;

    @Autowired
    private ModelMapper modelMapper;

    public List<DeviceDTO> getDevice(){
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
