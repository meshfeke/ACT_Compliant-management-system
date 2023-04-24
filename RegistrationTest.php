use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase
{
    public function testRegistration()
    {
        // Test code here
		$registration = new Registration();

    // Test valid input values
    $result = $registration->register('John', 'Doe', 'johndoe@example.com', 'password');
    $this->assertTrue($result);

    // Test invalid input values
    $result = $registration->register('', '', 'invalidemail', '');
    $this->assertFalse($result);
}


    }
}