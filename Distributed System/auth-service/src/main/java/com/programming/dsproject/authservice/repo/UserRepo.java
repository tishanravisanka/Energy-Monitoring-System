package com.programming.dsproject.authservice.repo;

        import com.programming.dsproject.authservice.dto.UserDTO;
        import com.programming.dsproject.authservice.entity.Users;
        import org.springframework.data.jpa.repository.JpaRepository;
        import org.springframework.data.jpa.repository.Query;

public interface UserRepo extends JpaRepository<Users,Integer> {

        @Query(value = "SELECT * FROM Users e WHERE e.email = ?1",nativeQuery = true)

        Users getUsersByEmail(String email);
}