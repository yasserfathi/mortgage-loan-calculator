import { useState, useEffect } from 'react';
import { Card, Row, Col, Spinner } from 'react-bootstrap';

type Stats = {
  amortization: number;
  extraRepayment: number;
};

const DEFAULT_STATS: Stats = {
  amortization: 0,
  extraRepayment: 0
};

function LoanDashboard() {
  const [stats, setStats] =useState<Stats>(DEFAULT_STATS);

  useEffect(() => {
    async function getStats() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/loans/total');
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const response_data = await response.json();
        
        if (!response_data.data || typeof response_data.data.amortization !== 'number') {
          throw new Error('Invalid data format received');
        }

        setStats(response_data.data);
      } catch (e) {
        console.log(e);
      }
    }

    getStats();
  }, []);

  return (
    <Row className="g-4 mb-4">
      <Col md={6} className="mb-4">
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">Amortization Loans</h6>
                <h3 className="mb-0">{stats.amortization}</h3>
              </div>
              <div className="bg-success bg-opacity-10 p-3 rounded">
                <i 
                  className="bi bi-graph-up text-success" 
                  style={{ fontSize: '1.5rem' }}
                  aria-hidden="true"
                />
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>

      <Col md={6} className="mb-4">
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">Extra Payments Loans</h6>
                <h3 className="mb-0">{stats.extraRepayment}</h3>
              </div>
              <div className="bg-success bg-opacity-10 p-3 rounded">
                <i 
                  className="bi bi-cash-stack text-success" 
                  style={{ fontSize: '1.5rem' }}
                  aria-hidden="true"
                />
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>

      <Col md={12} className="mb-4">
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">All Loans</h6>
                <h3 className="mb-0">{stats.amortization+stats.extraRepayment}</h3>
              </div>
              <div className="bg-success bg-opacity-10 p-3 rounded">
                <i 
                  className="bi bi-coin text-success" 
                  style={{ fontSize: '1.5rem' }}
                  aria-hidden="true"
                />
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>
    </Row>
  );
}

export default LoanDashboard;