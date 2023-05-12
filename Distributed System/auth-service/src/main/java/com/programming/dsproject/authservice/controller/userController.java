package com.programming.dsproject.authservice.controller;

import com.programming.dsproject.authservice.dto.UserDTO;
import com.programming.dsproject.authservice.service.UserService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping(value = "api/user")
@Slf4j
public class userController {
    @Autowired
    private UserService userService;

    @GetMapping("/getUserByEmail/{email}")
    public  UserDTO getUserByEmail(@PathVariable String email){
        System.out.println(email);
        return userService.getUsersByEmail(email);
    }


    @PostMapping("/registerUser")
    public UserDTO registerUserUser(@RequestBody UserDTO addUserDTO){

        return userService.registerUser(addUserDTO);
    }
}


