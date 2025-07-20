import { Nav } from 'react-bootstrap';
import { useRouter } from 'next/router';

export default function AsideNav() {
  const router = useRouter();
  const currentPath = router.pathname;
  const currentNavLinkClass = (path: string) => currentPath === path ? 'text-success' : 'text-dark';
  return (
    <Nav defaultActiveKey={currentPath} className="flex-column p-3">
      <Nav.Link 
        href="/" className={`${currentNavLinkClass('/')} mb-2`} active={currentPath === '/'}
      >
        <i className="bi bi-speedometer2 me-2"></i> Dashboard
      </Nav.Link>
      <Nav.Link href="/loans" className={`${currentNavLinkClass('/loans')} mb-2`} active={currentPath === '/loans'}>
        <i className="bi bi-coin me-2"></i> Loans
      </Nav.Link>
      <Nav.Link href="/amortization" active={currentPath === '/amortization'} className={`${currentNavLinkClass('/amortization')} mb-2`}>
        <i className="bi bi-graph-up me-2"></i> Amortization
      </Nav.Link>
      <Nav.Link href="/extra_payment" active={currentPath === '/extra_payment'} className={`${currentNavLinkClass('/extra_payment')} mb-2`}>
        <i className="bi bi-cash-stack me-2"></i> Extra Payments
      </Nav.Link>
    </Nav>
  );
}