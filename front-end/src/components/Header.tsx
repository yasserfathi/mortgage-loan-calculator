import { Navbar, Nav, Container } from 'react-bootstrap';

export default function Header() {
  return (
    <Navbar bg="success" variant="dark" expand="lg" className="shadow-sm">
      <Container fluid className="d-flex justify-content-center">
        <Navbar.Brand>
          <i className="bi bi-calculator-fill me-2"></i>
          Mortgage Calculator
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="navbar" className="position-absolute start-0" /> {/* Keep toggle on left */}
      </Container>
    </Navbar>
  );
}