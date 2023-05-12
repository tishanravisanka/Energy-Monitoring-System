package com.programming.dsproject.authservice.service;


import com.programming.dsproject.authservice.dto.UserDTO;
import com.programming.dsproject.authservice.entity.Users;
import com.programming.dsproject.authservice.repo.UserRepo;
import jakarta.transaction.Transactional;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Collections;
import java.util.List;

@Service
@Transactional
public class UserService {

    @Autowired
    private UserRepo userRepo;

    @Autowired
    private ModelMapper modelMapper;

    public UserDTO registerUser(UserDTO userDTO){
        userRepo.save(modelMapper.map(userDTO, Users.class));
        return userDTO;
    }

    public UserDTO getUsersByEmail(String email){
        Users users = userRepo.getUsersByEmail(email);
        System.out.println(users);
        if(users != null){
            return modelMapper.map(users,UserDTO.class);
        }else {

            UserDTO user = new UserDTO();

            //List<String> EmptyList = Collections.<String>emptyList();
            return user;
        }

    }


}
