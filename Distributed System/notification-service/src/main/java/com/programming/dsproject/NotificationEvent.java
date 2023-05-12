package com.programming.dsproject;

import lombok.*;
import org.springframework.context.ApplicationEvent;


@Data
@AllArgsConstructor
@NoArgsConstructor
public class NotificationEvent {
    private String deviceNumber;
    private String temperature;

}
