package com.dup.demo.controller;

import com.dup.demo.domain.Result;
import com.dup.demo.domain.User;
import com.dup.demo.domain.group.Second;
import com.dup.demo.enums.ExceptionEnum;
import com.dup.demo.exception.AppException;
import com.dup.demo.service.UserService;
import com.dup.demo.utils.ResultUtil;
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
    public Result<List<User>> getAllUser() {
        return ResultUtil.success(userService.getAllUser());
    }

    @PostMapping("/getoneuser")
    public Result<User> getOneUser(@Validated({Second.class}) User user, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            ExceptionEnum.ARGS_ERROR.setMsg(bindingResult.getFieldError().getDefaultMessage());
            throw new AppException(ExceptionEnum.ARGS_ERROR);
        }
        return ResultUtil.success(userService.getOneUser(user.getId()));
    }

    @PostMapping("/adduser")
    @Transactional
    public Object addUser(@Validated({Second.class}) User user, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            ExceptionEnum.ARGS_ERROR.setMsg(bindingResult.getFieldError().getDefaultMessage());
            throw new AppException(ExceptionEnum.ARGS_ERROR);
        }
        return userService.addUser(user);
    }

}
