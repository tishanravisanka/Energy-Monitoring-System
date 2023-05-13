package com.programming.dsproject.deviceservice.dto;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@NoArgsConstructor
@AllArgsConstructor
@Data

public class DeviceDTO {

    private String device_name;
    private String min_temperature;
    private String max_temperature;
    private String min_humidity;
    private String max_humidity;
    private String min_voltage;
    private String max_voltage;
    private String email;


}
