package com.dup.demo.controller;

import com.dup.demo.domain.Result;
import com.dup.demo.domain.User;
import com.dup.demo.domain.group.Second;
import com.dup.demo.enums.ExceptionEnum;
import com.dup.demo.exception.AppException;
import com.dup.demo.service.UserService;
import com.dup.demo.utils.ResultUtil;
import io.swagger.annotations.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;
import springfox.documentation.annotations.ApiIgnore;

import java.util.List;

@Api(tags = "用户操作接口")
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

    @ApiOperation(value = "添加用户", notes = "添加用户")
    //@ApiImplicitParam(name = "user", value = "用户实体", required = true, dataType = "User")
    @ApiImplicitParams({
            @ApiImplicitParam(name = "id", value = "用户名ID", required = false, paramType = "query",dataType = "int"),
            @ApiImplicitParam(name = "name", value = "用户名", required = true, paramType = "query", dataType = "String"),
            @ApiImplicitParam(name = "password", value = "密码", required = true, paramType = "query", dataType = "String"),
            @ApiImplicitParam(name = "type", value = "类型", required = true, paramType = "query", dataType = "int"),
            @ApiImplicitParam(name = "status", value = "状态", required = true, paramType = "query", dataType = "int"),
            @ApiImplicitParam(name = "flag", value = "标识", required = true, paramType = "query", dataType = "String")
    })
    @PostMapping("/adduser")
    @Transactional
    public Object addUser(@Validated({Second.class}) User user, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            ExceptionEnum.ARGS_ERROR.setMsg(bindingResult.getFieldError().getDefaultMessage());
            throw new AppException(ExceptionEnum.ARGS_ERROR);
            //return ResultUtil.error(ExceptionEnum.ARGS_ERROR.getCode(), ExceptionEnum.ARGS_ERROR.getMsg());
        }
        return userService.addUser(user);
    }

    @PostMapping("/createuser")
    @Transactional
    public Object createUser(@Validated({Second.class}) User user, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            ExceptionEnum.ARGS_ERROR.setMsg(bindingResult.getFieldError().getDefaultMessage());
            throw new AppException(ExceptionEnum.ARGS_ERROR);
            //return ResultUtil.error(ExceptionEnum.ARGS_ERROR.getCode(), ExceptionEnum.ARGS_ERROR.getMsg());
        }
        return userService.createUser(user);
    }

}
