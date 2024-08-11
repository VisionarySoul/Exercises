Imaginary Tech Solutions - Discount Registration

This project provides a user-friendly interface for registering for discounts on imaginary products offered by Imaginary Tech Solutions. It utilizes a Docker container for easy deployment and scalability.

Features:

Form to register for discounts with name, email, product, coupon (optional), city, country, and address.
User interface with a modern design and clear instructions.
Basic validation of user input (required fields).
Server-side processing of discount registration using PDO and SQLite.
Ability to display a random coupon code upon user request.
Technologies:

Frontend: HTML, CSS, JavaScript
Backend: PHP (PDO for database interaction)
Database: SQLite (within the container)
Containerization: Docker
Setup:

Clone the repository:

Bash
git clone https://github.com/your-username/imaginary-discount-registration.git
Use code with caution.

Build the Docker image:

Bash
cd imaginary-discount-registration
docker build -t imaginary-discount .
Use code with caution.

Run the container:

Bash
docker run -d -p 8080:80 imaginary-discount
Use code with caution.

This command creates a detached container (-d) and exposes port 80 of the container to port 8080 of your host machine (-p 8080:80).
Accessing the application:

Open your web browser and navigate to http://localhost:8080 to access the discount registration form.

Usage:

Fill in the required information on the form.
Optionally, click the "Show Random Coupon" button to generate a random coupon code.
Click the "Register for Discount" button to submit your registration.
The server will process your request and display a success message if the registration is successful.

Notes:

This application uses a SQLite database stored within the Docker container. For production environments, consider using a more robust database solution.
The random coupon code generation functionality is for demonstration purposes only and should be replaced with a more secure implementation for real-world usage.
Contributing:

Feel free to submit pull requests with improvements or bug fixes. We welcome contributions from the community.

License:

This project is licensed under the MIT License.   

Additional Information:

You can customize the container's exposed port by modifying the -p flag when running the container.
To stop the running container, use the docker stop command followed by the container ID.
For further information on Docker commands, refer to the official Docker documentation: https://docs.docker.com/
I hope this comprehensive README file provides clear instructions and helpful insights into your Dockerized PHP application!
