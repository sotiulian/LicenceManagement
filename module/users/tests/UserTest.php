<?php
require_once './src/User.php'; // Adjust the path as necessary
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public function testCreateUser() {
        // Create a mock database connection object
        $mockDb = $this->createMock(PDO::class);

        // Create an instance of the User class with the mock database connection
        $user = new User($mockDb);
        $user->name = 'John Doe';
        $user->email = 'john.doe@example.com';
        $user->password = 'password123';

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertEquals('password123', $user->password);
    }
   
    public function testFilterUsers() {
        $mockDb = $this->createMock(PDO::class);
        $user = new User($mockDb);
    
        // Assuming you have a method to set the filter criteria
        $name = 'John';
        $email = 'john.doe@example.com'; 
        $date_of_birth_start = '2000-01-01'; 
        $date_of_birth_end = '2000-01-01'; 
        $networth_min = 0; 
        $networth_max = 100000; 
        $start = 1; 
        $limit = 15;
    
        $filteredUsers = $user->filter_users($name, $email, $date_of_birth_start, $date_of_birth_end, $networth_min, $networth_max, $start, $limit);
        $this->assertNotEmpty($filteredUsers, 'The filtered users list should not be empty.');
    }
    

    public function testInsertUser() {
        $mockDb = $this->createMock(PDO::class);
        $stmt = $this->createMock(PDOStatement::class);
    
        $mockDb->expects($this->once())
               ->method('prepare')
               ->willReturn($stmt);
    
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);
    
        $user = new User($mockDb);
        $user->name = 'John Doe';
        $user->email = 'john.doe@example.com';
        $user->password = 'password123';
        $user->date_of_birth = '2000-01-01 00:00:00';
        $user->networth = 1000.00;
    
        $result = $user->create();
        $this->assertTrue($result, 'User should be created successfully.');
    }
   

    public function testInvalidEmail() {
        $mockDb = $this->createMock(PDO::class);
        $user = new User($mockDb);
        $user->email = 'invalid-email';
    
        $this->assertFalse($user->validateEmail(), 'The email validation should fail for an invalid email address.');
    }
    
    public function testValidEmail() {
        $mockDb = $this->createMock(PDO::class);
        $user = new User($mockDb);
        $user->email = 'john.doe@example.com';
    
        $this->assertTrue($user->validateEmail(), 'The email validation should pass for a valid email address.');
    }
    

}
