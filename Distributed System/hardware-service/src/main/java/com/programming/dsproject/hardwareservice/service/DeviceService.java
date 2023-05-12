package com.programming.dsproject.hardwareservice.service;

import com.programming.dsproject.hardwareservice.dto.DeviceDTO;
import com.programming.dsproject.hardwareservice.entity.Device_1;
import com.programming.dsproject.hardwareservice.event.NotificationEvent;
import com.programming.dsproject.hardwareservice.repo.DeviceRepo;
import jakarta.transaction.Transactional;
import lombok.RequiredArgsConstructor;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.kafka.core.KafkaTemplate;
import org.springframework.stereotype.Service;

@Service
@Transactional
@RequiredArgsConstructor
public class DeviceService {

    private final KafkaTemplate<String, NotificationEvent> kafkaTemplate;

    @Autowired
    private DeviceRepo deviceRepo;

    @Autowired
    private ModelMapper modelMapper;

    public DeviceDTO saveDevicesNoData(DeviceDTO deviceDTO){
        deviceRepo.save(modelMapper.map(deviceDTO, Device_1.class));
        if(Integer.parseInt(deviceDTO.getTemperature())>50){
            NotificationSend(new NotificationEvent("1",deviceDTO.getTemperature()));
        }
        return deviceDTO;
    }

    public void NotificationSend(NotificationEvent event){

        kafkaTemplate.send("notificationTopic", new NotificationEvent(event.getDeviceNumber(), event.getTemperature()));
    }

    
}
