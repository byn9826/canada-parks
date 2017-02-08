import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Rate from './snippet/Rate';
let data = [
	{commentid: 0, userid: 0, name: "Paul", parkid: 0, park: "Banff", time: "2017-01-26", rate: "5", pic: "0", comment: "Very beautiful, will be there again one day."},
	{commentid: 1, userid: 0, name: "Paul", parkid: 1, park: "Jasper", time: "2017-01-26", rate: "5", pic: "0", comment: "Even better than Banff."},
	{commentid: 2, userid: 1, name: "BAO", parkid: 2, park: "Algonquin", time: "2017-01-26", rate: "4", pic: "0", comment: "Good to spend two day with family."},
	{commentid: 3, userid: 1, name: "BAO", parkid: 2, park: "Algonquin", time: "2017-01-26", rate: "4", pic: "0", comment: "just to test the maximum length, 12345678 ,  here here here here here here here here here here here hereherehereherehere herehere here here here here."}
];
let data1 = [
	{commentid: 0, userid: 0, name: "Paul", parkid: 0, park: "Banff", time: "2017-01-26", rate: "5", pic: "0", comment: "Very beautiful, will be there again one day."},
	{commentid: 2, userid: 1, name: "BAO", parkid: 2, park: "Algonquin", time: "2017-01-26", rate: "4", pic: "0", comment: "Good to spend two day with family."}
];
let data2 = [
	{commentid: 1, userid: 0, name: "Paul", parkid: 1, park: "Jasper", time: "2017-01-26", rate: "5", pic: "0", comment: "Even better than Banff."},
	{commentid: 3, userid: 1, name: "BAO", parkid: 2, park: "Algonquin", time: "2017-01-26", rate: "4", pic: "0", comment: "just to test the maximum length, 12345678 ,  here here here here here here here here here here here hereherehereherehere herehere here here here here."}
];
let teamPath;
if (window.location.pathname.indexOf("/park")===-1) {
	teamPath = "./";
} else {
	teamPath = "../";
}
class Comment extends Component {
	render() {
		let commentLeft = this.props.data1.map(
			(commentL)=>(
				<section key={"marvelcanadacommentleft"+commentL.commentid} className="comment-single">
					<div className="comment-single-left">
						<img src={this.props.path + "static/img/users/profile/"+commentL.userid+".png"} />
						<div>
							<h4>{commentL.name}</h4>
							<Rate rate={commentL.rate} max="5" />
						</div>
						<h5>{commentL.comment}</h5>
						<div>
							<h5>@{commentL.park}</h5>
							<h5>{commentL.time}</h5>
						</div>
					</div>
					<img alt={commentL.name+" in "+commentL.park} src={this.props.path + "static/img/park/"+commentL.parkid+"/"+commentL.pic+".jpg"} />
				</section>
		    )
		);
		let commentRight = this.props.data2.map(
			(commentR)=>(
				<section key={"marvelcanadacommentright"+commentR.commentid} className="comment-single">
					<div className="comment-single-left">
						<img src={this.props.path + "static/img/users/profile/"+commentR.userid+".png"} />
						<div>
							<h4>{commentR.name}</h4>
							<Rate rate={commentR.rate} max="5" />
						</div>
						<h5>{commentR.comment}</h5>
						<div>
							<h5>@{commentR.park}</h5>
							<h5>{commentR.time}</h5>
						</div>
					</div>
					<img alt={commentR.name+" in "+commentR.park} src={this.props.path + "static/img/park/"+commentR.parkid+"/"+commentR.pic+".jpg"} />
				</section>
		    )
		);
		return (
			<div className="col-md-12 col-sm-12 col-xs-12">
				<div className="col-md-6">
					{commentLeft}
				</div>
				<div className="col-md-6">
					{commentRight}
				</div>
			</div>
		)
	}
};
ReactDOM.render(<Comment data1={data1} data2={data2} path={teamPath} />, document.getElementById('userComment'));
