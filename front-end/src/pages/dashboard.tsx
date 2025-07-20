import React from 'react';
import { Card, Row, Col } from 'react-bootstrap';

export default function DashboardCards() {
  // Sample data - replace with your actual data
  const stats = {
    activeLoans: 12,
    totalPrincipal: 4500000,
    interestSaved: 125000,
    avgLoanTerm: 27.5
  };

  return (
    <Row className="g-4 mb-4">
      {/* Active Loans Card */}
      <Col md={6} lg={3}>
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">Active Loans</h6>
                <h3 className="mb-0">{stats.activeLoans}</h3>
              </div>
              <div className="bg-primary bg-opacity-10 p-3 rounded">
                <i className="bi bi-clipboard2-data-fill text-primary" style={{ fontSize: '1.5rem' }}></i>
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>

      {/* Total Principal Card */}
      <Col md={6} lg={3}>
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">Total Principal</h6>
                <h3 className="mb-0">${(stats.totalPrincipal / 1000).toFixed(1)}K</h3>
              </div>
              <div className="bg-success bg-opacity-10 p-3 rounded">
                <i className="bi bi-cash-stack text-success" style={{ fontSize: '1.5rem' }}></i>
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>

      {/* Interest Saved Card */}
      <Col md={6} lg={3}>
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">Interest Saved</h6>
                <h3 className="mb-0">${stats.interestSaved.toLocaleString()}</h3>
              </div>
              <div className="bg-warning bg-opacity-10 p-3 rounded">
                <i className="bi bi-graph-down-arrow text-warning" style={{ fontSize: '1.5rem' }}></i>
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>

      {/* Average Loan Term Card */}
      <Col md={6} lg={3}>
        <Card className="h-100 shadow-sm border-0">
          <Card.Body className="p-4">
            <div className="d-flex justify-content-between align-items-center">
              <div>
                <h6 className="text-uppercase text-muted mb-2">Avg Loan Term</h6>
                <h3 className="mb-0">{stats.avgLoanTerm} <small className="text-muted">yrs</small></h3>
              </div>
              <div className="bg-info bg-opacity-10 p-3 rounded">
                <i className="bi bi-calendar-range text-info" style={{ fontSize: '1.5rem' }}></i>
              </div>
            </div>
          </Card.Body>
        </Card>
      </Col>
    </Row>
  );
}