package com.programming.dsproject.hardwareservice.event;

import lombok.Getter;
import lombok.Setter;
import org.springframework.context.ApplicationEvent;


@Getter
@Setter
public class NotificationEvent extends ApplicationEvent {
    private String deviceNumber;
    private String temperature;

    public NotificationEvent(Object source, String deviceNumber, String temperature) {
        super(source);
        this.deviceNumber = deviceNumber;
        this.temperature = temperature;
    }

    public NotificationEvent(String deviceNumber, String temperature) {
        super(deviceNumber);
        this.deviceNumber = deviceNumber;
        this.temperature = temperature;
    }
}
