import { useState, useEffect } from 'react';
import { Container, Table, Card } from 'react-bootstrap';

type Loan = {
  id: number;
  principal: number;
  annual_interest_rate: number;
  term_years: number;
  total_interest_paid: number;
};

function LoanDashboard() {
  const [loans, setLoans] =  useState<Loan[]>([]);

  useEffect(() => {
    async function getLoans() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/loans');
        const response_data = await response.json();
        setLoans(response_data.data);
      } catch (err) {
        console.log(err);
      }
    }
    getLoans();
  }, []);

  return (
    <Container className="py-4">
      <Card className="shadow-sm">
        <Card.Body>
          <Table striped bordered hover>
            <thead>
              <tr>
                <th>ID</th>
                <th>principal</th>
                <th>annual_interest_rate</th>
                <th>term_years</th>
                <th>total_interest_paid</th>
              </tr>
            </thead>
            <tbody>
              {loans.length > 0 ? (
                loans.map(loan => (
                  <tr key={loan.id} style={{ cursor: 'pointer' }}>
                    <td>{loan.id}</td>
                    <td>{loan.principal}</td>
                    <td>{loan.annual_interest_rate}%</td>
                    <td>{loan.term_years}</td>
                    <td>{loan.total_interest_paid}</td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan={5} className="text-center py-3">
                    No loans found
                  </td>
                </tr>
              )}
            </tbody>
          </Table>
        </Card.Body>
      </Card>
    </Container>
  );
}

export default LoanDashboard;