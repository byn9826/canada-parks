import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Rate from './snippet/Rate';
let data = [
	{userid: 0, name: "Paul", parkid: 0, park: "Banff", time: "2017-01-26", rate: "5", pic: "0", comment: "Very beautiful, will be there again one day."},
	{userid: 0, name: "Paul", parkid: 1, park: "Jasper", time: "2017-01-26", rate: "5", pic: "0", comment: "Even better than Banff."},
	{userid: 1, name: "BAO", parkid: 2, park: "Algonquin", time: "2017-01-26", rate: "4", pic: "0", comment: "Good to spend two day with family."},
]
class Comment extends Component {
	render() {
		let comments = this.props.data.map(
			(comment)=>(
				<section key={comment.userid+"/"+comment.parkid} className="comment-single">
					<img src={"static/img/users/profile/"+comment.userid+".png"} />
					<div>
						<h4>{comment.name}</h4>
						<Rate rate={comment.rate} max="5" />
					</div>
					<div>
						<h5>@{comment.park}</h5>
						<h5>{comment.time}</h5>
					</div>
					<h5>{comment.comment}</h5>
					<img alt={comment.name+" in "+comment.park} src={"static/img/park/"+comment.parkid+"/"+comment.pic+".jpg"} />
				</section>
		    )
		);
		return (
			<div className="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
				{comments}
			</div>
		)
	}
};
ReactDOM.render(<Comment data={data} />, document.getElementById('comment'));
