package com.dup.demo.aspect;

import org.aspectj.lang.JoinPoint;
import org.aspectj.lang.annotation.*;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;

import javax.servlet.http.HttpServletRequest;

@Aspect
@Configuration
public class HttpAspect {
    private final static Logger logger = LoggerFactory.getLogger(HttpAspect.class);

    /* 定义一个切入点 */
    @Pointcut("execution(public * com.dup.demo.controller.UserController.*(..))")
    public void doPointCut() {
    }

    /* 通过连接点切入 */
    @Before("doPointCut()")
    public void doBefore(JoinPoint joinPoint) {
        //System.out.println("------------aop test-------------");
        logger.info("------------aop start test-------------");

        ServletRequestAttributes attributes = (ServletRequestAttributes) RequestContextHolder.getRequestAttributes();
        HttpServletRequest request = attributes.getRequest();
        //url
        logger.info("url={}", request.getRequestURL());

        //method
        logger.info("method={}", request.getMethod());

        //ip
        logger.info("ip={}", request.getRemoteAddr());

        //类方法
        logger.info("class_method={}", joinPoint.getSignature().getDeclaringTypeName() + "." +
                joinPoint.getSignature().getName());

        //参数
        logger.info("args={}", joinPoint.getArgs());
    }

    @After("doPointCut()")
    public void doAfter() {
        logger.info("------------aop end test-------------");
    }

    @AfterReturning(returning = "object", pointcut = "doPointCut()")
    public void doAfterReturning(Object object) {
        logger.info("response={}", object.toString());
    }

}