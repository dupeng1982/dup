package com.dup.demo.controller;

import com.dup.demo.properties.SiteProperties;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

//@RestController
@Controller
public class HelloController {
    @Autowired
    private SiteProperties siteProperties;

    @Value("${site.name}")
    private String sitename;

    //@RequestMapping(value = "/hello", method = RequestMethod.GET)
    @PostMapping(value = {"/hello", "hi"})
    @ResponseBody
    public String sayHello() {
        return "Hello Spring Boot!" + sitename + siteProperties.getRecordcode();
    }

    //模板使用
    @GetMapping("/temp")
    public String getTemp() {
        return "index";
    }

    //参数获取
    @GetMapping("/say")
    @ResponseBody
    //public int saySome(@PathVariable("id") int id) {
    public int saySome(@RequestParam(value = "id", required = false, defaultValue = "0") int id) {
        //public int saySome(@PathVariable("id") int id) {
        return id;
    }

}
