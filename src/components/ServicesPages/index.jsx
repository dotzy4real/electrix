import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import Services from './Services.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/services.jpeg';

function ServicesPages() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="What We Do"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'What We Do' },
                ]}
                banner = {PageBanner}
            />
            <Services />
            <Footer />
            <BackToTop />
        </>
    );
}

export default ServicesPages;
