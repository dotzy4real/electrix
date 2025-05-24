import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import PricingPage from './Pricing.jsx';

function PricingPage2() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Pricing"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/pricing', title: 'Pricing' },
                ]}
            />
            <PricingPage />
            <Footer />
            <BackToTop />
        </>
    );
}

export default PricingPage2;
