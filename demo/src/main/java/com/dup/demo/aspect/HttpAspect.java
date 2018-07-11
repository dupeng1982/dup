package com.dup.demo.aspect;

import org.aspectj.lang.annotation.Aspect;
import org.aspectj.lang.annotation.Before;
import org.aspectj.lang.annotation.Pointcut;
import org.springframework.context.annotation.Configuration;

@Aspect
@Configuration
public class HttpAspect {
    /* 定义一个切入点 */
    @Pointcut("execution(public * com.dup.demo.controller.UserController.*(..))")
    public void doPointCut() {
    }

    /* 通过连接点切入 */
    @Before("doPointCut()")
    public void doBefore() {
        System.out.println("------------aop test-------------");
    }

}