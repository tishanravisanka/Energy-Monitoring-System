package com.programming.dsproject.repo;

import com.programming.dsproject.entity.Devices;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

public interface DeviceRepo extends JpaRepository<Devices,String> {

    @Query(value = "SELECT * FROM Devices e WHERE e.email = ?1",nativeQuery = true)

    Devices getDevicesByEmail(String email);

}
