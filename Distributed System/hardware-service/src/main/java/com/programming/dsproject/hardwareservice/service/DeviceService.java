package com.programming.dsproject.hardwareservice.service;

import com.programming.dsproject.hardwareservice.dto.DeviceDTO;
import com.programming.dsproject.hardwareservice.entity.Device_1;
import com.programming.dsproject.hardwareservice.event.NotificationEvent;
import com.programming.dsproject.hardwareservice.repo.DeviceRepo;
import jakarta.transaction.Transactional;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.kafka.core.KafkaTemplate;
import org.springframework.stereotype.Service;
import org.springframework.web.reactive.function.client.WebClient;

@Service
@Transactional
@RequiredArgsConstructor
@Slf4j
public class DeviceService {

    private final KafkaTemplate<String, NotificationEvent> kafkaTemplate;
    private final WebClient webClient;

    @Autowired
    private DeviceRepo deviceRepo;

    @Autowired
    private ModelMapper modelMapper;

    public DeviceDTO saveDevicesNoData(DeviceDTO deviceDTO){
        String deviceName = "1";

        if(Integer.parseInt(deviceDTO.getTemperature())>50){
            NotificationSend(new NotificationEvent(deviceName,deviceDTO.getTemperature()));
        }
        if(chkDeviceAvailability(deviceName)){
            deviceRepo.save(modelMapper.map(deviceDTO, Device_1.class));
        }

        return deviceDTO;
    }

    public boolean chkDeviceAvailability(String deviceName){
//        return Boolean.TRUE.equals(webClient.get()
//                .uri("http://device-service/api/devicelist/getDeviceExist",
//                        uriBuilder -> uriBuilder.queryParam("deviceName", deviceName).build())
//                .retrieve()
//                .bodyToMono(Boolean.class)
//                .block());
        System.out.println(deviceName);
        String url = "http://device-service/api/devicelist/getDeviceExist";

        webClient.get()
                .uri(uriBuilder -> uriBuilder
                        .path(url)
                        .queryParam("deviceName", deviceName)
                        .build())
                .accept(MediaType.APPLICATION_JSON)
                .retrieve()
                .bodyToMono(Boolean.class)
                .subscribe(response -> {
                    // Handle the response here
                    System.out.println(response);
//                    return response;
                }, error -> {
                    // Handle the error here
                    System.err.println("An error occurred: " + error.getMessage());
                });

        return true;

    }

    public void NotificationSend(NotificationEvent event){

        kafkaTemplate.send("notificationTopic", new NotificationEvent(event.getDeviceNumber(), event.getTemperature()));
    }

    
}
