#include <bits/stdc++.h>
using namespace std;

void print(string str, int low, int high)
{
	for (int i = low; i <= high; ++i)
		cout << str[i];
}


void longest(string str)
{
	int n = str.size();
	int maxLength = 1, start = 0;
	for (int i = 0; i < str.length(); i++) {
		for (int j = i; j < str.length(); j++) {
			int flag = 1;
			for (int k = 0; k < (j - i + 1) / 2; k++)
				if (str[i + k] != str[j - k])
					flag = 0;
			if (flag && (j - i + 1) > maxLength) {
				start = i;
				maxLength = j - i + 1;
			}
		}
	}

	cout << "longest palindrom from given string is :"<<endl;
	print(str, start, start + maxLength - 1);

}


int main()
{
    string str ;
    cout<<"Enter the string"<<endl;
    cin>>str;

	 longest(str);
	return 0;
}
