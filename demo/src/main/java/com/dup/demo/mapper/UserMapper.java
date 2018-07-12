package com.dup.demo.mapper;

import com.dup.demo.domain.User;
import org.apache.ibatis.annotations.*;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface UserMapper {
    @Select("select * from users")
    @Results({
            @Result(property = "id", column = "id"),
            @Result(property = "name", column = "name"),
            @Result(property = "password", column = "password")
    })
    List<User> getAllUser();

    @Select("select * from users where id = #{id}")
    User getOneUser(Long id);

    @Insert("insert into users(name,password,type,status) VALUES(#{name},#{password},#{type},#{status})")
    @Options(useGeneratedKeys = true, keyProperty = "id", keyColumn = "id")
    int addUser(User user);
}
