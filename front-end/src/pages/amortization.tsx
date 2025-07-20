import { useState } from 'react';
import { Container, Button, Modal, Form, Table, Card, Alert } from 'react-bootstrap';

type Amortization = {
  month_number: number;
  starting_balance: number;
  monthly_payment: number;
  principal_component: number;
  interest_component: number;
  ending_balance: number;
};

type LoanFormData = {
  principal: string;
  annual_interest_rate: string;
  term_years: string;
};

type FormErrors = {
  principal?: string;
  annual_interest_rate?: string;
  term_years?: string;
};

function LoanDashboard() {
  const [amortization, setAmortization] = useState<Amortization[]>([]);
  const [showModal, setShowModal] = useState(false);
  const [showTable, setTable] = useState(false);
  const [formData, setFormData] = useState<LoanFormData>({
    principal: '',
    annual_interest_rate: '',
    term_years: ''
  });
  const [errors, setErrors] = useState<FormErrors>({});
  const [submitError, setSubmitError] = useState<string | null>(null);

  const validateForm = (): boolean => {
    const newErrors: FormErrors = {};
    const principal = parseFloat(formData.principal);
    const interestRate = parseFloat(formData.annual_interest_rate);
    const termYears = parseInt(formData.term_years);

    // Principal
    if (!formData.principal) {
      newErrors.principal = 'Principal is required';
    } else if (isNaN(principal)) {
      newErrors.principal = 'Must be a valid number';
    } else if (principal <= 0) {
      newErrors.principal = 'Must be greater than 0';
    }

    // Interest rate validation
    if (!formData.annual_interest_rate) {
      newErrors.annual_interest_rate = 'Interest rate is required';
    } else if (isNaN(interestRate)) {
      newErrors.annual_interest_rate = 'Must be a valid number';
    } else if (interestRate <= 0) {
      newErrors.annual_interest_rate = 'Must be greater than 0';
    }

    // Term validation
    if (!formData.term_years) {
      newErrors.term_years = 'Term is required';
    } else if (isNaN(termYears)) {
      newErrors.term_years = 'Must be a valid number';
    } else if (termYears <= 0) {
      newErrors.term_years = 'Must be at least 1 year';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    
    if (errors[name as keyof FormErrors]) {
      setErrors(prev => ({ ...prev, [name]: undefined }));
    }
  };

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    setSubmitError(null);
    
    if (!validateForm()) {
      return;
    }

    try {
      const response = await fetch('http://127.0.0.1:8000/api/loans', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          principal: parseFloat(formData.principal),
          annual_interest_rate: parseFloat(formData.annual_interest_rate),
          term_years: parseInt(formData.term_years)
        }),
      });

      const resultData = await response.json();

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Failed to save loan');
      }

      setTable(false);

      // Get Amortization Data
      const updatedResponse = await fetch('http://127.0.0.1:8000/api/amortization/'+resultData.data.loan_id);
      const response_data = await updatedResponse.json();
      setAmortization(response_data.data)
      
      setFormData({ principal: '', annual_interest_rate: '', term_years: '' });
      setTable(true);
      setShowModal(false);
    } catch (err) {
      setSubmitError(err instanceof Error ? err.message : 'An unknown error occurred');
    }
  };

  return (
    <Container className="py-4">
      <div className="d-flex justify-content-between mb-4">
        <Button variant="success" size="lg" className="w-100" onClick={() => setShowModal(true)}>
          Calculate New Loan +
        </Button>
      </div>

      {showTable && (
      <Card className="shadow-sm">
        <Card.Body>
          <Table striped bordered hover>
            <thead>
              <tr>
                <th>Month No.</th>
                <th>Starting Balance</th>
                <th>Monthly Payment</th>
                <th>Principal Component</th>
                <th>Interest Component</th>
                <th>Ending Balance</th>
              </tr>
            </thead>
            <tbody>
              {amortization.length > 0 ? (
                amortization.map(amortization => (
                  <tr key={amortization.month_number} style={{ cursor: 'pointer' }}>
                    <td>{amortization.month_number}</td>
                    <td>{amortization.starting_balance}</td>
                    <td>{amortization.monthly_payment}</td>
                    <td>{amortization.principal_component}</td>
                    <td>{amortization.interest_component}</td>
                    <td>{amortization.ending_balance}</td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan={6} className="text-center py-3">
                    No loans found
                  </td>
                </tr>
              )}
            </tbody>
          </Table>
        </Card.Body>
      </Card>
  )}

      <Modal show={showModal} onHide={() => setShowModal(false)}>
        <Modal.Header closeButton>
          <Modal.Title className="text-success">
            Add New Loan
          </Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {submitError && <Alert variant="danger">{submitError}</Alert>}
          <Form onSubmit={handleSubmit} noValidate>
            <Form.Group className="mb-3">
              <Form.Label>Principal ($)</Form.Label>
              <Form.Control 
                type="number" 
                name="principal"
                value={formData.principal}
                onChange={handleChange}
                required
                min="0"
                isInvalid={!!errors.principal}
              />
              <Form.Control.Feedback type="invalid">
                {errors.principal}
              </Form.Control.Feedback>
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>Interest Rate (%)</Form.Label>
              <Form.Control 
                type="number" 
                name="annual_interest_rate"
                value={formData.annual_interest_rate}
                onChange={handleChange}
                step="0.01"
                required
                min="0"
                max="100"
                isInvalid={!!errors.annual_interest_rate}
              />
              <Form.Control.Feedback type="invalid">
                {errors.annual_interest_rate}
              </Form.Control.Feedback>
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>Term (Years)</Form.Label>
              <Form.Control 
                type="number" 
                name="term_years"
                value={formData.term_years}
                onChange={handleChange}
                required
                min="1"
                max="50"
                isInvalid={!!errors.term_years}
              />
              <Form.Control.Feedback type="invalid">
                {errors.term_years}
              </Form.Control.Feedback>
            </Form.Group>

            <div className="d-flex justify-content-end mt-4">
              <Button 
                variant="outline-secondary" 
                onClick={() => setShowModal(false)}
                className="me-2"
              >
                Cancel
              </Button>
              <Button variant="success" type="submit">
                Save Loan
              </Button>
            </div>
          </Form>
        </Modal.Body>
      </Modal>
    </Container>
  );
}

export default LoanDashboard;