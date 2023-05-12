package com.programming.dsproject.hardwareservice.dto;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@NoArgsConstructor
@AllArgsConstructor
@Data

public class DeviceDTO {

    private int id;
    private String temperature;
    private String humidity;
    private String heatindex;
    private String voltage;
    private String current;
    private String power;
    private String frequency;
    private String created_at;
    private String updated_at;


}
