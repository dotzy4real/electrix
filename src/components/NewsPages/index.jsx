import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import News from './News.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/blog.jpeg';

function NewsPages() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Blog"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'Blog' },
                ]}
                banner = {PageBanner}
            />
            <News />
            <Footer />
            <BackToTop />
        </>
    );
}

export default NewsPages;
