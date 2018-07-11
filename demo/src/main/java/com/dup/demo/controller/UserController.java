package com.dup.demo.controller;

import com.dup.demo.domain.User;
import com.dup.demo.domain.group.First;
import com.dup.demo.domain.group.Second;
import com.dup.demo.service.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping(value = "/user")
public class UserController {
    @Autowired
    private UserService userService;

    @GetMapping("/getalluser")
    public List<User> getAllUser() {
        return userService.getAllUser();
    }

    @PostMapping("/getoneuser")
    public User getOneUser(@RequestParam("id") Long id){
        return userService.getOneUser(id);
    }

    @PostMapping("/adduser")
    @Transactional
    public Object addUser(@Validated({Second.class}) User user, BindingResult bindingResult){
        if (bindingResult.hasErrors()) {
            return bindingResult.getFieldError().getDefaultMessage();
        }
        return userService.addUser(user);
    }
}
