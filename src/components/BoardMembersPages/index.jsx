import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import BoardMembers from './BoardMembers.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/board members.png';

function BoardDirectorPages() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Board Members"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'Board Members' },
                ]}
                 banner={PageBanner}
            />
            <BoardMembers />
            <Footer />
            <BackToTop />
        </>
    );
}

export default BoardDirectorPages;
