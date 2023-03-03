
#include <bits/stdc++.h>
using namespace std;


struct Node {
	int data;
	struct Node* next;
};

void push(struct Node** head_ref, int new_data)
{

	struct Node* new_node = new Node;
	new_node->data = new_data;
	new_node->next = (*head_ref);
	(*head_ref) = new_node;
}

void makeloop(Node** head_ref, int k)
{
   if(k==-1){
       
   }
   else
   {
    Node* temp = *head_ref;
    int count = 1;
    while (count < k) {
        temp = temp->next;
        count++;
    }
    Node* kth_node = temp;
    while (temp->next != NULL)
        temp = temp->next;
    temp->next = kth_node;
}
}


int countNodes(Node *ptr)
{
	int count = 0;
	while (ptr != NULL)
	{
		ptr = ptr->next;
		count++;
	}
	return count;
}

bool detectLoop(struct Node* h)
{
	unordered_set<Node*> s;
	while (h != NULL) {
		if (s.find(h) != s.end())
			return true;
		s.insert(h);

		h = h->next;
	}

	return false;
}


int main()
{
	
	struct Node* head = NULL;
	
	int n,i,a[50];
	cout<<"Enter the number of elements "<<endl;
	cin>>n;
	
	cout<<"Enter the element one by one"<<endl;
	for(i=0;i<n;i++){
	    cin>>a[i];
	    push(&head, a[i]);
	}

    int k ;
	cout<<"Enter the postion to make loop"<<endl;
	cin>>k;
	

    
	int total_nodes = countNodes(head);
    makeloop(&head, k);

	if (detectLoop(head))
		cout << "yes linked list have cyle";
	else
		cout << "No linked list have no cycle";

	return 0;
}

