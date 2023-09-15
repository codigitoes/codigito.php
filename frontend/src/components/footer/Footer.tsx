import React from 'react';
import './footer.scss';

interface FooterProps {
}

const Footer: React.FC<FooterProps> = ({ }) => {
    return (
        <>
            <div className='footer'>
                <span>codigito.es</span>
                <span>@copy</span>
            </div>
        </>
    );
};

export default Footer;
