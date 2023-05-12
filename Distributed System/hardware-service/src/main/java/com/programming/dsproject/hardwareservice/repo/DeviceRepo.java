package com.programming.dsproject.hardwareservice.repo;

import com.programming.dsproject.hardwareservice.entity.Device_1;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

public interface DeviceRepo extends JpaRepository<Device_1,Integer> {

}
