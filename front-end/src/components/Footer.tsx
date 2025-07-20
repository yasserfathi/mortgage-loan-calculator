import { Container, Col, Row } from 'react-bootstrap';

export default function Footer() {
  return (
    <footer className="bg-light gray-white py-3 mt-auto">
      <Container fluid className="d-flex justify-content-center">
        <Row>
          <Col md={12}>
            <p className="mb-0">&copy; {new Date().getFullYear()} Mortgage Calculator</p>
          </Col>
        </Row>
      </Container>
    </footer>
  );
}