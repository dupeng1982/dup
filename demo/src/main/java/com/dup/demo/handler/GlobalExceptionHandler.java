package com.dup.demo.handler;

import com.dup.demo.domain.Result;
import com.dup.demo.enums.ExceptionEnum;
import com.dup.demo.exception.AppException;
import com.dup.demo.utils.ResultUtil;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.ResponseBody;

@ControllerAdvice
public class GlobalExceptionHandler {
    @ExceptionHandler(value = Exception.class)
    @ResponseBody
    public Result defaultHandler(Exception e) {
        if (e instanceof AppException) {
            AppException appException = (AppException) e;
            return ResultUtil.error(appException.getCode(), appException.getMessage());
        } else if (e instanceof NullPointerException) {
            return ResultUtil.error(ExceptionEnum.NULL_POINTER_ERROR.getCode(), ExceptionEnum.NULL_POINTER_ERROR.getMsg());
        } else if (e instanceof UsernameNotFoundException) {
            return ResultUtil.error(ExceptionEnum.USERNAME_NOT_FOUND_ERROR.getCode(), ExceptionEnum.USERNAME_NOT_FOUND_ERROR.getMsg());
        } else {
            if (e.getMessage().isEmpty()) {
                return ResultUtil.error(ExceptionEnum.UNKOWN_ERROR.getCode(), ExceptionEnum.UNKOWN_ERROR.getMsg());
            } else {
                return ResultUtil.error(ExceptionEnum.ERROR.getCode(), e.getMessage());
            }
        }
    }
}
