// src/components/Layout.tsx

import React, { ReactNode } from 'react';
import Header from './Header';
import Footer from './Footer';
import AsideNav from './AsideNav';

const Layout = ({ children }: { children: ReactNode }) => {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
      <Header />
      <div style={{ display: 'flex', flex: 1 }}>
        <AsideNav />
        <main style={{ flex: 1, padding: '1rem' }}>{children}</main>
      </div>
      <Footer />
    </div>
  );
};

export default Layout;
