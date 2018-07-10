package com.dup.demo.Controller;

import com.dup.demo.Properties.SiteProperties;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

@Controller
public class HelloController {
    @Autowired
    private SiteProperties siteProperties;

    @Value("${site.name}")
    private String sitename;

    //@RequestMapping(value = "/hello", method = RequestMethod.GET)
    @PostMapping("/hello")
    @ResponseBody
    public String sayHello() {
        return "Hello Spring Boot!" + sitename + siteProperties.getRecordcode();
    }

    //模板使用
    @GetMapping("/temp")
    public String getTemp() {
        return "index";
    }
}
